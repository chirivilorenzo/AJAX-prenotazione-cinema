# Database realizzato con phpmyadmin

### utente
- ID : int AUTO_INCREMENT
- username : varchar(16)
- password : varchar(32)
- amministratore : int DEFAULT 0
- PRIMARY KEY (ID)


### film
- ID : int AUTO_INCREMENTE
- titolo : varchar(32)
- genere : varchar(16)
- durata : int
- locandina : blob
- PRIMARY KEY (ID)


### genere
- ID : int AUTO_INCREMENT
- nome : varchar(16)
- PRIMARY KEY (ID)


### film-genere
- idFilm : int
- idGenere : int
- FOREIGN KEY (idFilm) REFERENCES film(ID)
- FOREIGN KEY (idGenere) REFERENCES genere(ID)