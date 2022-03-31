import pymysql
import cgi
import webbrowser

#database connection
connection = pymysql.connect(host="127.0.0.1",user="root",passwd="",database="login" )
cursor = connection.cursor()
# some other statements  with the help of cursor
retrive = "Select * from users;"
cursor.execute(retrive)
rows = cursor.fetchall()

form = cgi.FieldStorage()
searchterm =  form.getvalue('fname')
print(searchterm)

connection.close()