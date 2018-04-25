pipeline {
  agent any
  stages {
    stage('deps') {
      steps {
        sh 'composer install'
        sh 'sudo ./vendor/phpunit/phpunit -c phpunit.xml'
      }
    }
  }
}