describe('Formulaire de génération de pdf', () => {
    it('test 1 - génération OK', () => {
        cy.visit('http://127.0.0.1:8000/pdf');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#url').type('https://www.youtube.com');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();
    });

    it('test 2 - génération KO', () => {
        cy.visit('http://127.0.0.1:8000/pdf');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#url').type('caca');

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();

        // Vérifier que le message d'erreur est affiché
        cy.contains('Invalid credentials.').should('exist');
    });
});