# Database realizzato con phpmyadmin

### utente
-  `ID` int(11) NOT NULL,
-  `username` varchar(16) NOT NULL,
-  `password` varchar(32) NOT NULL,
-  `email` varchar(64) NOT NULL,
-  `amministratore` int(11) NOT NULL DEFAULT 0,
-  `2FA` int(11) NOT NULL DEFAULT 0,
-  `codiceRegistrazione` varchar(32) NOT NULL


### film
-  `ID` int(11) NOT NULL,
-  `titolo` varchar(32) NOT NULL,
-  `durata` int(11) NOT NULL,
-  `locandina` varchar(16) NOT NULL


### genere
-  `ID` int(11) NOT NULL,
-  `nome` varchar(16) NOT NULL


### film-genere
-  `ID` int(11) NOT NULL,
-  `idFilm` int(11) NOT NULL,
-  `idGenere` int(11) NOT NULL
- FOREIGN KEY (idFilm) REFERENCES film(ID)
- FOREIGN KEY (idGenere) REFERENCES genere(ID)