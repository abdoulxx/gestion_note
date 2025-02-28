#!/usr/bin/env python3
import time
import os
from zapv2 import ZAPv2

# URL de l'application cible
target = 'https://regisono.com'

# Récupération de la clé API ZAP depuis les variables d'environnement
apiKey = os.getenv("ZAP_API_KEY")

# Vérification de la présence de la clé API
if not apiKey:
    print("❌ ERREUR : La clé API ZAP n'est pas définie. Vérifiez votre pipeline.")
    exit(1)

# Connexion à l'API OWASP ZAP avec le bon port
zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8080', 'https': 'http://127.0.0.1:8080'})

# Vérifier la connexion
try:
    print(f"🔄 Connexion à ZAP... Version : {zap.core.version}")
except Exception as e:
    print(f"❌ ERREUR : Impossible de se connecter à ZAP : {e}")
    exit(1)

# Attendre que ZAP soit prêt
print("⏳ Attente du démarrage de ZAP...")
time.sleep(10)

# Vérifier si l'API est accessible
try:
    version = zap.core.version
    print(f"✅ ZAP est prêt (Version : {version})")
except Exception as e:
    print(f"❌ ERREUR : L'API ZAP ne répond pas : {e}")
    exit(1)

# Lancer le Spider Scan
print(f"🕷 Lancement du Spider sur {target}")
scanID = zap.spider.scan(target)

# Vérifier si le scan a démarré correctement
if scanID.isdigit():
    while int(zap.spider.status(scanID)) < 100:
        print(f"⏳ Progression du scan : {zap.spider.status(scanID)}%")
        time.sleep(2)

    print("✅ Spider terminé avec succès !")
    print("\n🌍 URLs découvertes :")
    print('\n'.join(zap.spider.results(scanID)))
else:
    print("❌ Échec du lancement du Spider. Vérifiez l'API ZAP.")
    exit(1)
