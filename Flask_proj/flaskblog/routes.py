import os
from PIL import Image
from flask import render_template,url_for,flash,redirect,request,abort,Flask,jsonify
from flaskblog import app,bcrypt
from flask_login import login_user, current_user, logout_user, login_required
import numpy as np
import pandas as pd
from sklearn.model_selection import train_test_split
from sklearn.linear_model import LinearRegression


@app.route("/")
def temp():
	return "Hello"


import requests
import io
import tweepy
from textblob import TextBlob
from datetime import datetime,timedelta
import keras
from keras.models import model_from_json

@app.route('/senddata',methods=['GET'])
def test():
	dataset=pd.read_csv('path_to/Salary_Data.csv')
	X = dataset.iloc[:,:-1].values
	X=X.tolist()
	y = dataset.iloc[:,1].values
	y=y.tolist()
	X_train, X_test, y_train, y_test = train_test_split(X,y,test_size=1/3,random_state=0)
	compute(X_train,y_train)
	return jsonify({'X_test':X_test})

def compute(X_train,y_train):
	regressor.fit(X_train,y_train)

@app.route('/getdata',methods=['POST'])
def testing():
	X_test=request.json["X_test"]
	y_pred= regressor.predict(X_test)
	y_pred=y_pred.tolist()
	return jsonify(y_pred)


@app.route('/stocks/<stock_name>',methods=['GET'])
def stockpred(stock_name):
	stock_name=stock_name.replace("_", " ")
	#load model
	#get twitter sentiment
	ACCESS_TOKEN = "Your_access_token"
	ACCESS_TOKEN_SECRET = "Your_access_token_secret"
	CONSUMER_KEY = "Your_consumer_key"
	CONSUMER_SECRET = "Your_consumer_secret"
	currdate=datetime.datetime.now().date()
	prevdate=currdate-timedelta(days=10)
	auth=tweepy.OAuthHandler(consumer_key=CONSUMER_KEY,consumer_secret=CONSUMER_SECRET)
	auth.set_access_token(ACCESS_TOKEN,ACCESS_TOKEN_SECRET)
	api=tweepy.API(auth)

	###Extract today's tweet
	tweets=tweepy.Cursor(api.search,q=stock_name,lang="en",since=prevdate, until=currdate).items(15)
	tweetlist=[]
	tweetval=[]
	pos=0
	neg=0
	neutral=0
	polarity=0
	for tweet in tweets:
	    analysis = TextBlob(tweet.text)
	    tweetlist.append(tweet.text.encode('utf-8'))
	    tweetval.append(analysis.sentiment.polarity)
	    polarity+=analysis.sentiment.polarity
	    if(analysis.sentiment.polarity>0):
	    	pos=pos+1
	    elif(analysis.sentiment.polarity<0):
	    	neg=neg+1
	    else:
	    	neutral=neutral+1	
	    ###

	    ##appending this new value
	# print(tweetlist)
	return jsonify({'pos':pos,'polarity':polarity,'neg':neg,'neutral':neutral},headers={})

import pandas as pd
import numpy as np
import datetime
import requests
import io

@app.route('/movingaverage/<symbol>',methods=['POST'])
def movingaverage(symbol):
	CSV_URL='https://www.alphavantage.co/query?function=FX_DAILY&from_symbol='+symbol+'&to_symbol=INR&datatype=csv&apikey=YOUR_API_KEY'
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
	return jsonify({'datearray':datearray,'closearray':closearray,'datearray':datearray})