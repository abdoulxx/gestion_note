#!/usr/bin/env python
import time
from zapv2 import ZAPv2

# URL de l'application à tester
target = 'https://regisono.com'
# Clé API de ZAP
apiKey = '1odfud9vtbks0u32430lmt6cqc'

# Connexion à l'API de ZAP
zap = ZAPv2(apikey=apiKey, proxies={'http': 'http://127.0.0.1:8081', 'https': 'http://127.0.0.1:8081'})

print(f"Scan Spider en cours sur {target}...")

# ✅ Optimisation : Limiter la profondeur et le temps du scan
zap.spider.set_option_max_depth(2)  # Profondeur max à 2 niveaux
zap.spider.set_option_max_duration(30)  # Scan limité à 30 secondes

# ✅ Désactiver AJAX Spider pour accélérer (optionnel)
zap.ajaxSpider.stop()

# ✅ Exclure certaines pages si nécessaire (ex: contact, blog)
zap.spider.exclude_from_scan('https://regisono.com/contact*')
zap.spider.exclude_from_scan('https://regisono.com/blog*')

# Lancement du scan Spider
scanID = zap.spider.scan(target)
while int(zap.spider.status(scanID)) < 100:
    print(f"Progression du Spider: {zap.spider.status(scanID)}%")
    time.sleep(1)

print("Scan Spider terminé.")
print("URLs explorées par le Spider :")
print('\n'.join(map(str, zap.spider.results(scanID))))

# ✅ Lancement du scan actif pour détecter les vulnérabilités
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

# ✅ Génération d'un rapport HTML
zap.core.htmlreport()
print("Rapport de sécurité généré.")
