#!/usr/bin/env python
import time
from zapv2 import ZAPv2

# URL de l'application à tester
target = 'https://regisono.com'
# Clé API de ZAP
apiKey = '1odfud9vtbks0u32430lmt6cqc'

# Connexion à l'API de ZAP (assurez-vous que ZAP est lancé)
zap = ZAPv2(apikey=apiKey)

print(f"Scan Spider en cours sur {target}...")

# Lancement du scan Spider
scanID = zap.spider.scan(target)
while int(zap.spider.status(scanID)) < 100:
    print(f"Progression du Spider: {zap.spider.status(scanID)}%")
    time.sleep(1)

print("Scan Spider terminé.")
print("URLs explorées par le Spider :")
print('\n'.join(map(str, zap.spider.results(scanID))))

# Lancement du scan actif pour détecter les vulnérabilités
print("Lancement du scan actif...")
scanID = zap.ascan.scan(target)
while int(zap.ascan.status(scanID)) < 100:
    print(f"Progression du scan actif: {zap.ascan.status(scanID)}%")
    time.sleep(1)

print("Scan actif terminé.")
print("Rapport des alertes de sécurité détectées :")

alerts = zap.core.alerts(baseurl=target)
for alert in alerts:
    print(f"Risque: {alert['risk']} - {alert['alert']} - {alert['url']}")

# Génération d'un rapport au format HTML
zap.core.htmlreport()
print("Rapport de sécurité généré.")
