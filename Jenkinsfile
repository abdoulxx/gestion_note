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
                script {
                    def exitCode = bat(returnStatus: true, script: '''
                        vendor\\bin\\phpstan analyse --level=max src/ --no-progress --error-format=table --memory-limit=2G
                    ''')
                    if (exitCode != 0) {
                        echo " PHPStan a trouvé des erreurs, mais on continue l'exécution du pipeline."
                    }
                }
            }
        }

        stage('SQL Injection Test 1') {
            steps {
                bat '''
                    "C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\Scripts\\sqlmap.exe" \
                    -u "https://regisono.com/login.php?id=1" \
                    --batch --dbs --random-agent --tamper=space2comment \
                    --cookie="PHPSESSID=9db53e743d9bb20e8c28a075ef6132b6"
                '''
            }
        }

        stage('SQL Injection Test 2 (Automatisation)') {
            steps {
                bat '''
                    "C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\automatisation_sqlmap.py
                '''
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
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_tests.py'
            }
        }

        stage('Run Selenium Tests - Test 2') {
            steps {
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\selenium_test_pack_or.py'
            }
        }
        */

        stage('Run spider') {
            steps {
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\spider.py'
            }
        }

        stage('Run Scan_active') {
            steps {
                bat '"C:\\Users\\aboul\\AppData\\Local\\Programs\\Python\\Python313\\python.exe" tests\\active_scan.py'
            }
        }

        stage('Run form_authentication') {
            steps {
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
