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
        stage('Static Analysis') {
            parallel {
                stage('Code Style') {
                    steps {
                        // Vérifie le respect du standard PSR-12
                        bat 'vendor\\bin\\phpcs --standard=PSR12 src'
                    }
                }
                stage('Static Code Analysis') {
                    steps {
                        // Analyse statique du code avec PHPStan
                        bat 'vendor\\bin\\phpstan analyse src --level max'
                    }
                }
            }
        }
        stage('Run Unit Tests') {
            steps {
                // Exécute les tests unitaires et génère un rapport JUnit
                bat 'vendor\\bin\\phpunit --configuration phpunit.xml --coverage-html coverage --log-junit test-results.xml'
            }
        }
        stage('Audit de sécurité') {
            steps {
                // Vérifie les vulnérabilités dans les dépendances
                bat 'composer audit'
            }
        }
    }
    post {
        always {
            // Publie le rapport de tests
            junit 'test-results.xml'
            // Archive le rapport de couverture de code (HTML)
            archiveArtifacts artifacts: 'coverage/**', allowEmptyArchive: true
        }
    }
}
