pipeline {
  agent any
  stages {
    stage('deps') {
      parallel {
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
  }
}