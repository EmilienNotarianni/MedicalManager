	/* ********************************************************************/
	/* ******************     DATA BASE - MEDICAL     *********************/
	/* ******************             v1              *********************/
	/* ********************************************************************/

	/* * MEDICAL * */
	CREATE TABLE mp_user (
	email VARCHAR(255) NOT NULL,
	pass VARCHAR(255) NOT NULL,
	categorie enum('Medecin', 'Secretaire', 'Employes') NOT NULL,
	nom VARCHAR(255) NOT NULL,
	prenom VARCHAR(255) NOT NULL,
	naissance DATE NOT NULL,
	genre enum('Monsieur', 'Madame', 'Mademoiselle') NOT NULL,
	addr_num INT NOT NULL,
	addr_rue VARCHAR(255) NOT NULL,
	addr_ville VARCHAR(255) NOT NULL,
	addr_dep INT(5) NOT NULL,
	addr_pays VARCHAR(255) NOT NULL,
	addr_compl VARCHAR(255),
	antMedicaux TEXT,
	vaccinations VARCHAR(255),
	PRIMARY KEY (email)
	);

	insert into mp_user values (
		'emilien.notarianni@gmail.com',
		'd1bfaa72671177d4d17bb440c9decacd2414b4996aa5cd9098ef365c72815d63fb1f15822e324752edd46ce4100ebedb22dab85fb5bcd624bf542f5bd6c005df',
		'Medecin',
		'Notarianni',
		'Emilien',
		'1992-04-12',
		'Monsieur',
		7,
		'Allée Edouard Manet',
		'Gournay sur Marne',
		'93460',
		'France',
		'None',
		'Tout va bien',
		'Rage');
		
	insert into mp_user values (
		'emilien.notarianni@numericable.fr',
		'd1bfaa72671177d4d17bb440c9decacd2414b4996aa5cd9098ef365c72815d63fb1f15822e324752edd46ce4100ebedb22dab85fb5bcd624bf542f5bd6c005df',
		'Employes',
		'Notarianni',
		'Emilien',
		'1992-04-12',
		'Monsieur',
		7,
		'Allée Edouard Manet',
		'Gournay sur Marne',
		'93460',
		'France',
		'None',
		'Tout va bien',
		'Rage');
		
	insert into mp_user values (
		'emilien.notarianni@wanadoo.fr',
		'd1bfaa72671177d4d17bb440c9decacd2414b4996aa5cd9098ef365c72815d63fb1f15822e324752edd46ce4100ebedb22dab85fb5bcd624bf542f5bd6c005df',
		'Infirmiere',
		'Notarianni',
		'Emilien',
		'1992-04-12',
		'Monsieur',
		7,
		'Allée Edouard Manet',
		'Gournay sur Marne',
		'93460',
		'France',
		'None',
		'Tout va bien',
		'Rage');