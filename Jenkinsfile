pipeline {
  agent any
  stages {
    stage('deps') {
      steps {
        sh 'composer install'
        sh 'vendor/bin/phpunit tests'
      }
    }
  }
}