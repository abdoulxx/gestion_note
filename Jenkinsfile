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
                // Installation des dépendances PHP via Composer
                bat 'composer install'
                // (Optionnel) Installation des dépendances Python si vous avez un fichier requirements.txt
                bat 'pip install -r requirements.txt'
            }
        }
        stage('Build') {
            steps {
                echo "Build stage : Compilation / Packaging (si nécessaire)"
                // Pour un projet PHP, vous pouvez ajouter ici des étapes de build si besoin (ex: minification, etc.)
            }
        }
        stage('Run Tests') {
            steps {
                echo "Exécution des tests Selenium via le script Python"
                // Lancement du script Python Selenium (assurez-vous que le chemin est correct)
                bat 'python tests\\selenium_tests.py'
            }
        }
    }
    post {
        always {
            echo "Pipeline terminé"
            // Si votre script Selenium génère un rapport (par exemple en JUnit XML), vous pouvez le récupérer :
            // junit 'path/to/selenium-report.xml'
        }
    }
}
