pipeline {
  agent any
  stages {
    stage('deps') {
      steps {
        sh '''composer install
phpunit -c build.xml'''
      }
    }
  }
}