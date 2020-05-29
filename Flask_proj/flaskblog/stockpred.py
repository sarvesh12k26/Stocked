#STOCK PREDICTION REFERRED FROM ANALYTICS VIDHYA
###
#Loading the Data
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import datetime
from keras.models import model_from_json

#for viewing graphs in new window
#%matplotlib auto

plt.figure(figsize=(20,10))

from sklearn.preprocessing import MinMaxScaler
scaler = MinMaxScaler(feature_range=(0,1))

data = pd.read_csv('NSE-TATAGLOBAL.csv')
data.head()

###
#Set index as datetime field
data['Date']=pd.to_datetime(data.Date,format='%Y-%m-%d')
data.index=data['Date']

#Plotting the data
plt.figure(figsize=(7,5))
plt.plot(data['Close'],label='Closing Price History')

###
#Implementation
from keras.models import Sequential
from keras.layers import Dense, Dropout, LSTM

#create dataframe
dataset=data.sort_index(ascending=True, axis=0)
ndataset=pd.DataFrame(index=range(0,len(data)), columns=['Date','Close'])
ndataset[['Date','Close']]=dataset[['Date','Close']].values
#set index as date
ndataset.index=ndataset.Date
ndataset.drop('Date', axis=1, inplace=True)

#train and test datasets
temp=ndataset.values

##Trying out the same way as tutorial
findataset=ndataset.values
print(len(findataset))
train=findataset[0:int(len(findataset)*0.75),:]
valid=findataset[1575:,:]

#convert to xtrain ytrain
scaler=MinMaxScaler(feature_range=(0,1))
scaled_data=scaler.fit_transform(findataset)

x_train=[]
y_train=[]
for i in range(60,len(train)):
    x_train.append(scaled_data[i-60:i,0])
    y_train.append(scaled_data[i,0])
    
x_train, y_train=np.array(x_train), np.array(y_train)
#why to convert in 3-dimension
x_train1=np.reshape(x_train, (x_train.shape[0],x_train.shape[1],1))

#create the model and fit to the data
model=Sequential()
model.add( LSTM(units=50, return_sequences=True, input_shape=(x_train1.shape[1],1)) )    
model.add( LSTM(units=50) )
model.add(Dense(1))
model.compile(loss='mean_squared_error', optimizer='adam')
model.fit(x_train1, y_train, epochs=2, batch_size=50, verbose=2)

###This is part of validation###

#predict values, using past 60 from train data
inputs=ndataset[len(ndataset)-len(valid)-60:].values
inputs=inputs.reshape(-1,1)
inputs=scaler.transform(inputs)

X_test=[]
for i in range(60,inputs.shape[0]):
    X_test.append(inputs[i-60:i,0])
X_test=np.array(X_test)

X_test1=np.reshape(X_test, (X_test.shape[0],X_test.shape[1],1))
closing_price=model.predict(X_test1)
closing_price=scaler.inverse_transform(closing_price)

rms=np.sqrt(np.mean(np.power((valid-closing_price),2)))

#plot the actual vs predicted stock price
trainplot=ndataset[:1575]
validplot=ndataset[1575:]
validplot['Predictions']=closing_price
plt.figure(figsize=(5,3))
plt.plot(trainplot['Close'])
plt.plot(validplot[['Close','Predictions']])

###Validation Ends Here###

###############
testplot=pd.DataFrame(columns=['Date','Close'])

testdataset=ndataset[len(ndataset)-60:].values
testdataset=testdataset.reshape(-1,1)

###Making new further predictions
date = ndataset.index[-1]+ datetime.timedelta(days=1)
for i in range(30):
    testagain=testdataset[len(testdataset)-60:]
    testagain=scaler.transform(testagain)
    #print(testagain)
    testagain=np.reshape(testagain,(1,testagain.shape[0],1))
    test_price=model.predict(testagain)
    test_price=scaler.inverse_transform(test_price)
    testplot=testplot.append({'Date':date,'Close':test_price[0]}, ignore_index=True)
    date+=datetime.timedelta(days=1)
    ##appending this new value
    testdataset=np.append(testdataset,test_price)
    testdataset=testdataset.reshape(-1,1)
    #print(test_price)


testplot.index=testplot.Date
plt.plot(trainplot['Close'])
plt.plot(validplot[['Close','Predictions']])
plt.plot(testplot['Close'])


###save model
model_json = model.to_json()
with open("model.json", "w") as json_file:
    json_file.write(model_json)
model.save_weights("model.h5")

###load model
json_file = open('model.json', 'r')
loaded_model_json = json_file.read()
json_file.close()
loaded_model = model_from_json(loaded_model_json)
loaded_model.load_weights("model.h5")

    
