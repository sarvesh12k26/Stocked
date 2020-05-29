# -*- coding: utf-8 -*-
"""
Created on Sat Mar  2 14:41:36 2019




@author: Sarvesh
"""
#STOCK PREDICTION REFERRED FROM ANALYTICS VIDHYA
###
#Loading the Data
import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import datetime
from keras.models import model_from_json
import requests
import io

#for viewing graphs in new window
#%matplotlib auto

plt.figure(figsize=(20,10))

from sklearn.preprocessing import MinMaxScaler
scaler = MinMaxScaler(feature_range=(0,1))

#data = pd.read_csv('NSE-TATAGLOBAL.csv')

CSV_URL='https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=NSE:GODREJCP&datatype=csv&apikey=YOUR_API_KEY'
r = requests.get(CSV_URL)

if r.ok:
    print("Hello")
    data1 = r.content.decode('utf8')
    df = pd.read_csv(io.StringIO(data1))

df.head()

###
#Set index as datetime field
df['timestamp']=pd.to_datetime(df.timestamp,format='%Y-%m-%d')
df.index=df['timestamp']

#Plotting the data
plt.figure(figsize=(7,5))
plt.plot(df['close'],label='Closing Price History')

###
#Implementation
from keras.models import Sequential
from keras.layers import Dense, Dropout, LSTM

#create dataframe
dataset=df.sort_index(ascending=True, axis=0)
ndataset=pd.DataFrame(index=range(0,len(df)), columns=['timestamp','close'])
ndataset[['timestamp','close']]=dataset[['timestamp','close']].values
#set index as date
ndataset.index=ndataset.timestamp
ndataset.drop('timestamp', axis=1, inplace=True)

#train and test datasets
temp=ndataset.values

##Trying out the same way as tutorial
findataset=ndataset.values
print(len(findataset))
#train=findataset[0:int(len(findataset)*0.75),:]
train=findataset
#valid=findataset[1575:,:]

#convert to xtrain ytrain
scaler=MinMaxScaler(feature_range=(0,1))
scaled_data=scaler.fit_transform(findataset)

x_train=[]
y_train=[]
for i in range(10,len(train)):
    x_train.append(scaled_data[i-10:i,0])
    y_train.append(scaled_data[i,0])
    
x_train, y_train=np.array(x_train), np.array(y_train)

###Add twitter data here

###Twitter extraction###
import tweepy
from textblob import TextBlob
from datetime import datetime,timedelta

# Twitter Credentials
ACCESS_TOKEN = "Your_access_token"
ACCESS_TOKEN_SECRET = "Your_access_token_secret"
CONSUMER_KEY = "Your_consumer_key"
CONSUMER_SECRET = "Your_consumer_secret"

auth=tweepy.OAuthHandler(consumer_key=CONSUMER_KEY,consumer_secret=CONSUMER_SECRET)
auth.set_access_token(ACCESS_TOKEN,ACCESS_TOKEN_SECRET)
api=tweepy.API(auth)

prevdate=(datetime.today()-timedelta(days=90)).date()
currdate=datetime.today().date()
pol_val=[]
tweetlist=[]

tweets=tweepy.Cursor(api.search,q='godrej',lang="en",since=prevdate, until=currdate).items(90)
tweetval=[]
polarity=0
for tweet in tweets:
    analysis = TextBlob(tweet.text)
    tweetlist.append(tweet.text.encode('utf-8'))
    tweetval.append(analysis.sentiment.polarity)
    polarity+=analysis.sentiment.polarity
    
tweetval=np.asarray(tweetval)
tweetval=tweetval.reshape(-1,1)    
x_train=np.append(x_train,tweetval,axis=1)
###Twitter Ends###







###
#why to convert in 3-dimension
x_train1=np.reshape(x_train, (x_train.shape[0],x_train.shape[1],1))

#create the model and fit to the data
model=Sequential()
model.add( LSTM(units=50, return_sequences=True, input_shape=(x_train1.shape[1],1)) )    
model.add( LSTM(units=50) )
model.add(Dense(1))
model.compile(loss='mean_squared_error', optimizer='adam')
model.fit(x_train1, y_train, epochs=2, batch_size=1, verbose=2)


###############Testing begins###########
testplot=pd.DataFrame(columns=['timestamp','close'])

testdataset=ndataset[len(ndataset)-10:].values
testdataset=testdataset.reshape(-1,1)

###Making new further predictions
date = ndataset.index[-1]+ timedelta(days=1)
for i in range(1):
    testagain=testdataset[len(testdataset)-10:]
    ###Extract today's tweet
    tweets=tweepy.Cursor(api.search,q='bharat petrolium',lang="en",since=currdate, until=currdate).items(10)
    tweetval=[]
    polarity=0
    for tweet in tweets:
        analysis = TextBlob(tweet.text)
        tweetlist.append(tweet.text.encode('utf-8'))
        tweetval.append(analysis.sentiment.polarity)
        polarity+=analysis.sentiment.polarity
    ###
    testagain=scaler.transform(testagain)
    testagain=np.append(testagain,polarity)
    #print(testagain)
    testagain=np.reshape(testagain,(1,testagain.shape[0],1))
    test_price=model.predict(testagain)
    test_price=scaler.inverse_transform(test_price)
    testplot=testplot.append({'timestamp':date,'close':test_price[0]}, ignore_index=True)
    date+=timedelta(days=1)
    ##appending this new value
    testdataset=np.append(testdataset,test_price)
    testdataset=testdataset.reshape(-1,1)
    print(test_price)

testplot.index=testplot.timestamp
#plt.plot(trainplot['Close'])
#plt.plot(validplot[['Close','Predictions']])
plt.plot(testplot['close'])


###save model
model_json = model.to_json()
with open("GODREJCPmodel.json", "w") as json_file:
    json_file.write(model_json)
model.save_weights("GODREJCPmodel.h5")

###load model
json_file = open('model.json', 'r')
loaded_model_json = json_file.read()
json_file.close()
loaded_model = model_from_json(loaded_model_json)
loaded_model.load_weights("model.h5")

    

###FOREX TRADING
import pandas as pd
import numpy as np
import datetime
import requests
import io
CSV_URL='https://www.alphavantage.co/query?function=FX_DAILY&from_symbol=GBP&to_symbol=INR&datatype=csv&apikey=YOUR_API_KEY'
r = requests.get(CSV_URL)
if r.ok:
    print("Hello")
    data1 = r.content.decode('utf8')
    df = pd.read_csv(io.StringIO(data1))
    df=df[['timestamp','close']]
    
datearray=df['timestamp']
closearray=df['close']
datearray=datearray.tolist() 
closearray=closearray.tolist() 

x = np.asarray(closearray)
n=20
if type == 'simple':
	weights = np.ones(n)
else:
	weights = np.exp(np.linspace(-1., 0., n))

weights /= weights.sum()

a = np.convolve(x, weights, mode='full')[:len(x)]
a[:n] = a[n]
a=a.tolist()
a=a[20:]
datearray = datearray[:len(datearray)-20]
closearray = closearray[:len(closearray)-20]
