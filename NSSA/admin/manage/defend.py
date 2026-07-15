import os
import re
import config

def defend(ip):
#     禁ip命令:
#     '''iptables -A INPUT -p tcp -s 182.150.63.121 -j DROP
# iptables -A INPUT -p tcp -s 182.150.63.121 -j ACCEPT
# if iptables -A INPUT -p tcp -s 182.150.63.121 -j ACCEPT;then echo 1;fi '''
    try:
        cmd="if iptables -A INPUT -p tcp -s {} -j DROP;then echo 1;fi".format(ip)
        stream = os.popen(cmd)
        # 获取执行结果
        output = stream.read().split()
        stream.close()
        if output:
            return 0#防御成功
        return 1
    except:
        return 1

def accept(ip):
    try:
        cmd="if iptables -A INPUT -p tcp -s {} -j ACCEPT;then echo 1;fi".format(ip)
        stream = os.popen(cmd)
        # 获取执行结果
        output = stream.read().split()
        stream.close()
        if output:
            return 0
        return 1
    except:
        return 1

def lockfile(path):
    # 锁死文件夹
    # '''chattr -R +i /var/www/html'''
    # 解锁文件夹
    # ''' chattr -R -i /var/www/html'''
    try:
        cmd="if chattr -R +i {path};then echo 1;fi".format(path)
        stream = os.popen(cmd)
        # 获取执行结果
        output = stream.read().split()
        stream.close()
        if output:
            return 0
        return 1
    except:
        return 1
def unlockfile(path):
    try:
        cmd="if chattr -R -i {path};then echo 1;fi".format(path)
        stream = os.popen(cmd)
        # 获取执行结果
        output = stream.read().split()
        stream.close()
        if output:
            return 0
        return 1
    except:
        return 1


# def waffilter(x): #为了本系统的安全性，设置waf
#     sqlrule = config.sqlrule
#     xssrule=config.xssrule
#     backrule=config.backrule
#     rule=sqlrule+xssrule+backrule
#     x=x.strip()
#     for i in rule:
#         if i in x:
#             x = 'error'
#         else:
#             pass
#     return x
def waffilter(x):  # 为了本系统的安全性，设置waf
    if x is None:  # 检查 x 是否为 None
        return '101.43.143.195'  # 如果 x 是 None，直接返回 'error' 或其他默认值
    # 确保 x 是字符串类型，并去掉两端空白字符
    x = str(x).strip()
    sqlrule = config.sqlrule
    xssrule = config.xssrule
    backrule = config.backrule

    # 合并规则，使用集合去重，避免重复
    rule = set(sqlrule + xssrule + backrule)

    # 检查规则中是否有与 x 匹配的字符
    for i in rule:
        if i in x:
            return "101.43.143.195"  # 如果规则匹配到，返回 'error'

    return x  # 如果没有匹配，返回原始的 x