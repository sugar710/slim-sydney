pipeline {
  agent any
  stages {
    stage('deps') {
      steps {
        sh 'composer install'
      }
    }
    stage('test') {
      steps {
        sh 'phpunit'
      }
    }
  }
}