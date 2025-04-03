import firebase_admin
from firebase_admin import credentials
from firebase_admin import db
import pandas as pd




cred = credentials.Certificate("C:/Users/LENOVO/Documents/Python_Leche/proyectoleche-91725-firebase-adminsdk-fbsvc-0156dd017b.json")
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://proyectoleche-91725-default-rtdb.firebaseio.com/'
})

ref = db.reference('items/')
datos=ref.get()

for clave, vaca in datos.items():
    dato=f"{clave}"
    refs = db.reference('items/'+dato+'/produccion')
    if refs.get() is not None:
        print (refs.get())
   




