pipeline {
    agent any

    stages {
        stage('Checkout') {
            steps {
                // Récupération du code depuis GitHub sur la branche main
                git branch: 'main', url: 'https://github.com/abdoulxx/gestion_note.git'
            }
        }
        stage('Install Dependencies') {
            steps {
                // Installation des dépendances PHP via Composer
                bat 'composer install'
                // L'installation des dépendances Python est omise ici
            }
        }
        stage('Build') {
            steps {
                echo "Build stage: Compilation / Packaging (si nécessaire)"
                // Ajoutez ici vos commandes de build si besoin
            }
        }
        stage('Run Tests') {
            steps {
                echo "Exécution des tests Selenium via le script Python"
                // Lancement du script Selenium qui se trouve dans tests\selenium_tests.py
                bat 'python tests\\selenium_tests.py'
            }
        }
    }
    post {
        always {
            echo "Pipeline terminé"
            // Si votre script Selenium génère un rapport JUnit XML, décommentez la ligne suivante :
            // junit 'path/to/selenium-report.xml'
        }
    }
}
