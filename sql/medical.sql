	/* ********************************************************************/
	/* ******************     DATA BASE - MEDICAL     *********************/
	/* ******************             v1              *********************/
	/* ********************************************************************/

	/* * MEDICAL * */
	CREATE or REPLACE TABLE mp_user (
	email VARCHAR(255) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	categorie enum('Medecin', 'Secretaire', 'Employes') NOT NULL,
	nom VARCHAR(255) NOT NULL,
	prenom VARCHAR(255) NOT NULL,
	naissance DATE NOT NULL,
	genre enum('Monsieur', 'Madame', 'Mademoiselle') NOT NULL,
	addr_num INT NOT NULL,
	addr_rue INT NOT NULL,
	addr_ville VARCHAR(255) NOT NULL,
	addr_dep VARCHAR(255) NOT NULL,
	addr_pays VARCHAR(255) NOT NULL,
	addr_compl VARCHAR(255),
	antMedicaux TEXT,
	vaccinations VARCHAR(255),
	PRIMARY KEY (email)
	);
