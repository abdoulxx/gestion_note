pipeline {
    agent any

    triggers {
        cron('H */12 * * *') // Exécution automatique toutes les 12 heures
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/abdoulxx/gestion_note.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                bat 'composer install'
            }
        }
        stage('Build') {
            steps {
                echo "Build stage: Compilation / Packaging (si nécessaire)"
            }
        }
        /* 
        stage('Run Selenium Tests - Test 1') {
            steps {
                echo "Exécution du premier test Selenium"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_tests.py'
            }
        }
        stage('Run Selenium Tests - Test 2') {
            steps {
                echo "Exécution du deuxième test Selenium"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_test_pack_or.py'
            }
        }
        */ 
        stage('Run spider') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\spider.py'
            }
        }
        stage('Run Scan_active') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\active_scan.py'
            }
        }
        stage('Run form_autentification') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\form_autentification.py'
            }
        }
    }
    
    post {
        always {
            echo "Pipeline terminé"

            mail to: 'aboulayesamb@gmail.com',
                 subject: "[Jenkins] Exécution terminée : Pipeline gestion_note",
                 body: """Bonjour,

L'exécution du pipeline Jenkins est terminée.

- ✅ Résultat : ${currentBuild.result}
- 📅 Date : ${new Date()}
- 🔍 Consultez Jenkins pour plus de détails : ${env.BUILD_URL}

Cordialement,
Jenkins
"""
        }
    }
}