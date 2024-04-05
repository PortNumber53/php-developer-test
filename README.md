# Americor's PHP Developer Test Assignment

This review assignment is tailored to assess candidates' analytical, problem-solving, and code review skills.

### Task

As a candidate for the Senior PHP Developer role, you are provided with a segment of an existing codebase of a growing project. The project involves a multitude of 'event types' and 'objects' which presents a growing complexity - a key challenge to tackle. Your task is to conduct a thorough review of the provided code segment, focusing on identifying potential issues and areas for improvement. Continue on this task keeping in mind, the potential scaling of the project, considering the event types could grow beyond 150 with an average addition of 2 every month, and the objects could exceed a count of 30.

### What needs to be done:

1. **Code Review**: Perform an analysis of the existing code base, taking into account best development practices and standards.
2. **Propose Improvements**: Identify areas for improvement and propose specific improvement options.
3. **Focus on Performance and Maintainability:** Pay special attention to improving performance and maintaining the code for long-term efficiency.
4. **Provide Recommendations:** Provide recommendations for implementing development best practices, including separation of responsibilities, use of design patterns, and adherence to code formatting standards.

### Expected Deliverables

1. **Written Review:** A comprehensive report detailing your findings and suggestions. Your review should include:
    - **Identified Issues:** Specific problems or code smells detected within the codebase, with explanations.
    - **Improvement Suggestions:** Concrete recommendations for addressing each identified issue, including any proposed refactoring steps.
    - **Strategic Insights:** Commentary on how your suggestions align with best practices in PHP development, particularly regarding OOP principles, design patterns.
2. **Code Samples (Optional):** If applicable, include small snippets of code to illustrate your proposed solutions or improvements.

### Evaluation Criteria

When reviewing your solution, we will focus on the following aspects:

- **OOP Understanding**: Your grasp of Object-Oriented Programming concepts.
- **Design Patterns**: Your ability to effectively utilize design patterns in your solution.
- **Code Separation**: Your skill in segregating code logically for better readability and maintainability.
- **Problem Identification**: Your ability to identify and prioritize problems within the code.
- **Maintenance & Development**: How your approach facilitates future maintenance and development of the project.
- **Large Data Set Export**: Your solution for efficiently handling and exporting large data sets.

### How to run the project

The project is built using the Yii 2 framework. To run the project, follow the steps below:

1. Clone the repository to your local machine.
2. Run docker-compose to start the project:
   ```bash
   docker compose up --build -d
   ```
3. Connect to the PHP container:
   ```bash
   docker exec -it americor-app bash
   ```
4. Install the project dependencies:
   ```bash
    composer install
   ```
5. Run the migrations to create the database tables:
   ```bash
   php yii migrate
   ```
6. Access the project in your browser at `http://localhost:8000`.

### Conclusion

This test assignment is an opportunity to showcase your technical skills and problem-solving abilities. We look forward to seeing your solutions. Good luck!
