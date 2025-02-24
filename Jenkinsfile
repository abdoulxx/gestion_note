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
        stage('Run Tests') {
            steps {
                // Génération d'un rapport XML de test
                bat 'vendor\\bin\\phpunit --log-junit test-results.xml'
            }
        }
    }
    post {
        always {
            // Récupération du rapport de test généré
            junit 'test-results.xml'
        }
    }
}
