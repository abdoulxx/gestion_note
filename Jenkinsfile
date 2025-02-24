pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Clonage du repository depuis GitHub
                git branch: 'main', url: 'https://github.com/abdoulxx/gestion_note.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                // Installation des dépendances via Composer
                bat 'composer install'
            }
        }
        stage('Run Tests') {
            steps {
                // Exécution des tests avec PHPUnit
                bat 'vendor\\bin\\phpunit'
            }
        }
    }

    post {
        always {
            // Optionnel : Publier les résultats des tests si vous générez des rapports XML
            junit 'tests/**/*.xml'
        }
    }
}
