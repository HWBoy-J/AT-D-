# -*- coding: UTF-8 -*-

from functools import wraps
from flask import session,url_for, redirect,logging

# 登录状态检查
def logincheck(f):
    @wraps(f)
    def wrapper(*args, **kwargs):
        try:
            session['login'] = 'loginsuccess'   #在平台已经登录了，这里直接是登录状态
            if session.has_key('login'):
                if session['login'] == 'loginsuccess':
                    return f(*args, **kwargs)
                else:
                    return redirect(url_for('Login'))
            else:
                return redirect(url_for('Login'))
        except Exception, e:
            print e
            return redirect(url_for('Error'))

    return wrapper
