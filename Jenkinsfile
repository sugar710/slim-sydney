pipeline {
  agent any
  stages {
    stage('deps') {
      steps {
        sh 'composer install'
        sh 'phpunit tests'
      }
    }
  }
}