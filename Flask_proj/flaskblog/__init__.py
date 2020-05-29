from flask import Flask
from flask_sqlalchemy import SQLAlchemy
from flask_bcrypt import Bcrypt
from flask_login import LoginManager

app = Flask(__name__)
app.config['SECRET_KEY']='0cd095a97b3ddda55e8758d698c97953a791da49cc62ba57981e8381f0f0a1a2'
app.config['SQLALCHEMY_DATABASE_URI']='sqlite:///site.db'
bcrypt = Bcrypt(app)
login_manager = LoginManager(app)
login_manager.login_view = 'login'
login_manager.login_message_category = 'info'

from flaskblog import routes 

'''
for routing in url 
'''