# AWS PHP Web Application


## Project Overview

This project demonstrates how to design, deploy, and operate a real-world cloud-based PHP web application on AWS, following industry best practices.

The application enables users to submit and retrieve data through a PHP web interface. Structured data is stored in Amazon RDS (MySQL), optional file storage is supported using Amazon S3, and system access, monitoring, and logging are securely managed using IAM roles and Amazon CloudWatch.

This repository represents a production-ready cloud architecture commonly used in enterprise environments.



## Key Learning Outcomes

- Real-world AWS cloud architecture design
- Secure deployment using IAM roles (no hardcoded access keys)
- Integration with Amazon RDS (MySQL)
- Git-based development and deployment workflow
- Monitoring and logging using Amazon CloudWatch
- Interview-ready system explanation



## Architecture Overview

User (Browser)

   |
   v
   
EC2 Instance (Apache + PHP)

   |
   v

Amazon RDS (MySQL Database)

   |
   v
   
Amazon S3 (Optional File Storage)

   |
   v
   
Amazon CloudWatch (Monitoring & Logs)



## Technology Stack

### Cloud Services
- Amazon EC2 – Application server
- Amazon RDS (MySQL) – Managed relational database
- Amazon S3 – Optional file storage
- AWS IAM – Secure role-based access control
- Amazon CloudWatch – Logging and monitoring

### Application Stack
- PHP – Server-side scripting
- Apache HTTP Server
- MySQL

### DevOps & Version Control
- Git
- GitHub



## Application Features

- PHP-based user data submission form
- Data storage and retrieval using Amazon RDS
- Secure IAM role usage (no AWS access keys in source code)
- Optional file/image uploads to Amazon S3
- System metrics and logs monitored via CloudWatch
- Git-based source code management



## Security Best Practices

- IAM roles attached to EC2 instances
- No hardcoded AWS credentials
- RDS deployed in a private network (no public access)
- Database access restricted using security groups
- Principle of least privilege followed



## Repository Structure

aws-php-webapp/
|
|-- index.php        # User input form
|-- db.php           # Database connection logic
|-- display.php      # Displays stored user data
|-- .gitignore       # Git ignore rules
|-- README.md        # Project documentation



## Deployment Workflow

### Infrastructure Setup
- Create IAM role with permissions for S3 and CloudWatch
- Launch EC2 instance with Apache and PHP installed
- Create RDS MySQL instance with restricted access

### Application Deployment

cd /var/www/html
sudo git clone https://github.com/your-username/aws-php-webapp.git
sudo chown -R www-data:www-data /var/www/html

### Database Configuration

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50),
  email VARCHAR(100)
);



## Monitoring & Observability

- EC2 CPU and disk metrics monitored using CloudWatch
- Apache and application logs available for troubleshooting
- Alarm-ready architecture for proactive monitoring



## CI/CD Readiness

This project is designed to support:
- GitHub-based version control
- Automated deployments using AWS CodeDeploy
- Zero-downtime deployment strategies (future enhancement)



## Scalability & Future Enhancements

- Application Load Balancer
- Auto Scaling Group for EC2
- Multi-AZ RDS for high availability
- AWS Secrets Manager for credential management
- Infrastructure as Code (Terraform / CloudFormation)
- Enhanced frontend UI and validation



## Project Value

- Real-world AWS cloud experience
- Enterprise-level architecture
- Resume-ready project
- Interview-ready explanation


