# Backend server's main script

import os
from flask import Flask
from flask_cors import CORS
from config import config
from models import db
from controllers import controllers


# application initialize
app = Flask(__name__)
CORS(app)  # for Cross-Origin Request Sharing
config_name = os.environ.get('CONFIG_NAME') or 'default'
host = config[config_name].APP_HOST
port = config[config_name].APP_PORT
debug = config[config_name].DEBUG
use_reloader = config[config_name].USE_RELOADER
app.config.from_object(config[config_name])
config[config_name].init_app(app)
api_prefix = config[config_name].API_PREFIX
api_version = config[config_name].API_VERSION
app.register_blueprint(controllers, url_prefix='{:s}{:s}'.format(api_prefix, api_version))
db.app = app
db.init_app(app)


@app.after_request
def after_request(response):
    """
    For to allow us to host the server (REST API) and the client (e.g. AngularJS app)
    on different domains and different sub-domains.
    
    :param response: response that we need wrap
    :type  response: flask.wrappers.Response
    
    :return: wrapped response 
    :rtype   flask.wrappers.Response
    """
    response.headers.add('Access-Control-Allow-Origin', '*')
    response.headers.add('Access-Control-Allow-Headers', 'Content-Type')
    response.headers.add('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE')
    # Also - for fake server name
    response.headers.add('Server', 'DemoApp Web Server/0.1')
    return response


if __name__ == "__main__":
    # Main script running part
    app.run(host=host,
            port=port,
            debug=debug,
            use_reloader=use_reloader)
