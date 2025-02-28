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
        
        stage('Validate PHPStan Configuration') {
    steps {
        echo "Validation du fichier phpstan.neon"
        script {
            def exitCode = bat(
                returnStatus: true,
                script: 'vendor\\bin\\phpstan --debug'
            )
            if (exitCode != 0) {
                error("Le fichier phpstan.neon contient des erreurs. Veuillez les corriger.")
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
