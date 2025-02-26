pipeline {
    agent any

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
                echo "Build stage: Compilation / Packaging (si nécessaire)"
            }
        }
        stage('Run Tests') {
            steps {
                echo "Exécution des tests Selenium via le script Python"
                // Remplacez le chemin ci-dessous par le chemin complet vers votre python.exe
                bat '"C:\\Users\\aboul\\AppData\\Roaming\\Microsoft\\Windows\\Start Menu\\Programs\\Python 3.13\\python.exe" tests\\selenium_tests.py'
            }
        }
    }
    post {
        always {
            echo "Pipeline terminé"
        }
    }
}
