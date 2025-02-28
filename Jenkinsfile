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
        
        stage('Static Code Analysis') {
    steps {
        echo "Exécution du test SCA avec PHPStan"
        script {
            def exitCode = bat(
                returnStatus: true,
                script: 'vendor\\bin\\phpstan analyse --level=max --memory-limit=512M .'
            )
            if (exitCode != 0) {
                error("PHPStan a détecté des erreurs. Veuillez les corriger.")
            }
        }
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
        stage('Run spider') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\spider.py'
            }
        }
        stage('Run Scan_active') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\active_scan.py'
            }
        }
        stage('Run form_autentification') {
            steps {
                echo "Lancement du test de sécurité avec ZAP"
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\form_autentification.py'
            }
        }
    }
    post {
        always {
            echo "Pipeline terminé"
        }
    }
}
