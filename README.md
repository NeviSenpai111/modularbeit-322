
- [[#Projektbeschreibung]]
	- [[#Bücher Liste mit allen Büchern. Die Bücher sollen | Bücher]]
	- [[#Kunden Kunden suchen. Die Kunden sollen (Name, Vorname, ...) (Admin) | Kunden]]
	- [[#Administrator]]
- [[#Software-Ergonomie|Software-Ergonomie]]
- [[#Style Guidelines]]
- [[#Struktur]]
- [[#Navigation]]
- [[#Masken]]

# Projektbeschreibung

In der Modularbeit des Modules 322 geht es um eine Webseite und diese soll für eine Bibliothek sein welche eine Online für Bücher und Nutzer Verwaltung. 

Sie planen eine Webseite nach den folgenden Funktionalitäten: 

###### Bücher: Liste mit allen Büchern. Die Bücher sollen:
- sortiert (nach Katalog, Nummer, Name, Autor, Kategorie, ...) werden können 
- Filtern & suchen  (nach Katalog, Nummer, Name, Autor, Kategorie, Zustand ...) werden können 
- eingefügt werden können (Admin)
- geändert werden können  (Admin)
- gelöscht werden können  (Admin)

###### Kunden: Kunden suchen. Die Kunden sollen (Name, Vorname, ...):  (Admin)
- gefiltert (nach Namen, Vorname, Kunden seit wann, Kontakt per mail erwünscht...)  werden können  (Admin)
- einzufügen sein  (Admin)
- geändert werden können  (Admin)
- zu löschen sein  (Admin)

###### Administrator:  :  
- Login & Logout
- Password ändern
- Bücher: löschen, einfügen & ändern
- Kunden  ansehen, einfügen, ändern, löschen.

# Software-Ergonomie
#### Meine Ansätze: 
1. Keine zu hellen Farben.
2. Auf der Startseite ist alles direkt erreichbar 
3. Responsive Design
4. Die Suchleiste ist direkt schön in der Mitte
# Style Guidelines
  
.container {  
    display: flex;  
    flex-wrap: wrap;  
    gap: 10px;  
    justify-content: center;  
}  
  
.box {  
    padding: 10px;  
    margin: 10px;  
    width: 200px;  
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);  
    background-color: rgba(231, 229, 229, 0.5);  
    border-radius: 10px;  
}  
  
.box-details {  
    display: flex;  
    flex-direction: column;  
    gap: 10px;  
    padding: 10px;  
    margin: 10px;  
  
}  
  
header {  
    display: flex;  
    align-items: center; /* Center the text vertically */  
    width: 95%;  
    height: 75px;  
    margin: 20px auto;  
    background-color: rgba(117, 110, 110, 0.47);  
    color: white;  
    padding: 1em 0;  
    border-radius: 15px;  
    position: relative;  
    justify-content: space-between;  
}  
  
footer {  
    display: flex;  
    align-items: center; /* Center the text vertically */  
    width: 95%;  
    height: 75px;  
    margin: 20px auto;  
    background-color: rgba(117, 110, 110, 0.47);  
    color: white;  
    padding: 1em 0;  
    border-radius: 15px;  
    position: relative;  
    justify-content: space-between;  
}  
  
footer p {  
    margin: 0; /* Remove any default margin */  
    padding: 10px;  
    text-align: center;  
    flex-grow: 1;  
    position: sticky;  
}  
  
.header-container {  
    display: flex;  
    align-items: center;  
    justify-content: flex-start;  
}  
  
.logo {  
    margin-right: 0; /* Adjust the space between the logo and the header */  
    width: 100px; /* Adjust the width as needed */  
    height: 75px; /* Maintain aspect ratio */  
    object-fit: contain; /* Ensure the image fits within the specified dimensions */  
}  
  
header p {  
    margin: 0; /* Remove any default margin */  
    padding: 10px;  
    text-align: center;  
    flex-grow: 1;  
}  
  
.login-link {  
    color: white;  
    right : 20px;  
}  
  
body {  
    background: #404040;  
    font-family: 'Roboto', sans-serif;  
}  
  
  
.container-input {  
    position: relative;  
}  
  
.input {  
    width: 150px;  
    padding: 10px 0 10px 40px;  
    border-radius: 9999px;  
    border: solid 1px #333;  
    transition: all .2s ease-in-out;  
    outline: none;  
    opacity: 0.8;  
    align-content: center;  
  
  
}  
  
.book-details {  
    position: fixed;  
    top: 50%;  
    left: 50%;  
    transform: translate(-50%, -50%);  
    width: 60%;  
    height: 60%;  
    background-color: #575757;  
    z-index: 1000;  
    overflow: auto;  
    padding: 20px;  
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);  
    border-radius: 10px;  
}  
.blurred {  
    filter: blur(0px);  
}  
  
.container-input svg {  
    position: absolute;  
    top: 50%;  
    left: 10px;  
    transform: translate(0, -50%);  
}  
  
.input:focus {  
    opacity: 1;  
    width: 250px;  
}  
  
.search-form {  
    display: flex;  
    justify-content: center;  
    align-items: center;  
    margin: 20px 0;  
    scale: 150%;  
}  
  
.login-box {  
    padding: 10px;  
    text-align: center;  
    margin: 20px 0;  
    background-color: rgb(255, 255, 255);  
    border-radius: 10px;  
    color: black;  
    position: absolute;  
}  
  
.login-box hover {  
    background-color: rgba(231, 229, 229, 0.5);  
}  
  
.pagination-box {  
    padding: 10px;  
    margin: 20px 0;  
    border-radius: 10px;  
    background-color: rgba(255, 255, 255, 0.1);  
    text-align: center;  
}  
  
.pagination-box a {  
    margin: 0 5px;  
    padding: 5px 10px;  
    text-decoration: none;  
    color: #333;  
    background-color: #fff;  
    border-radius: 5px;  
    transition: background-color 0.3s;  
}  
  
.pagination-box a:hover {  
    background-color: rgba(231, 229, 229, 0.5);  
}  
  
.pagination-box a.active {  
    background-color: #333;  
    color: #fff;  
}  
  
.flex-container {  
    display: flex;  
    justify-content: space-between;  
    align-items: center;  
}  
  
.login-container {  
    display: flex;  
    flex-direction: column;  
    justify-content: center;  
    align-items: center;  
    height: auto; /* Adjust height to fit content */  
    background-color: rgba(255, 255, 255, 0.1);  
    padding: 20px;  
    border-radius: 10px;  
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);  
    margin: 20px auto; /* Center the container */  
    max-width: 400px; /* Set a maximum width */  
}  
  
.login-container h2 {  
    margin-bottom: 20px;  
}  
  
.login-container form {  
    display: flex;  
    flex-direction: column;  
    gap: 10px;  
}  
  
.login-container label {  
    margin-bottom: 5px;  
}  
  
.login-container input {  
    padding: 10px;  
    border-radius: 5px;  
    border: 1px solid #333;  
}  
  
.login-container button {  
    padding: 10px;  
    border-radius: 5px;  
    border: none;  
    background-color: #333;  
    color: white;  
    cursor: pointer;  
    transition: background-color 0.3s;  
}  
  
.login-container button:hover {  
    background-color: #555;  
}  
  
.error {  
    color: red;  
    margin-bottom: 10px;  
}  
  
.form-container {  
    display: flex;  
    flex-direction: column;  
    justify-content: center;  
    align-items: center;  
    background-color: rgba(255, 255, 255, 0.1);  
    padding: 20px;  
    border-radius: 10px;  
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);  
    margin: 20px 0;  
}  
  
.form-container h2 {  
    margin-bottom: 20px;  
}  
  
.form-container form {  
    display: flex;  
    flex-direction: column;  
    gap: 10px;  
}  
  
.form-container label {  
    display: flex;  
    flex-direction: column;  
    margin-bottom: 5px;  
}  
  
.form-container input {  
    padding: 10px;  
    border-radius: 5px;  
    border: 1px solid #333;  
}  
  
.form-container button {  
    padding: 10px;  
    border-radius: 5px;  
    border: none;  
    background-color: #333;  
    color: white;  
    cursor: pointer;  
    transition: background-color 0.3s;  
}  
  
.form-container button:hover {  
    background-color: #555;  
}  
  
.button {  
    padding: 10px 20px;  
    border-radius: 5px;  
    border: none;  
    color: #000000;  
    cursor: pointer;  
    transition: background-color 0.3s;  
    margin: 10px;  
}  
  
.button-edit {  
    background-color: #4CAF50; /* Green */  
}  
  
.button-edit:hover {  
    background-color: #45a049;  
}  
  
.button-delete {  
    background-color: #f44336; /* Red */  
}  
  
.button-delete:hover {  
    background-color: #da190b;  
}  
  
.button-add {  
    background-color: #ffffff; /* Green */  
}  
  
.button-add:hover {  
    background-color: #45a049;  
}  
  
.button-logout {  
    background-color: #ffffff; /* Red */  
}  
  
.button-logout:hover {  
    background-color: rgba(231, 229, 229, 0.5);  
}  
  
.button-home {  
    background-color: #ffffff; /* Blue */  
}  
  
.button-home:hover {  
    background-color: rgba(231, 229, 229, 0.5);  
}


# Struktur

Ordnerstruktur
# Navigation

Buttons welche sich im Header befinden. 

