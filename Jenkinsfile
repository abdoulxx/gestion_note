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
        /*
        stage('Run Selenium Tests - Test 1') {
            steps {
                echo "Exécution du premier test Selenium"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_tests.py'
            }
        }
        stage('Run Selenium Tests - Test 2') {
            steps {
                echo "Exécution du deuxième test Selenium"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_test_pack_or.py'
            }
        }
        */
        stage('Run ZAP Security Scan') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\spider.py'
            }
        }
    }
    post {
        always {
            echo "Pipeline terminé"
        }
    }
}
