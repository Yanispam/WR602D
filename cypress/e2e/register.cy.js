describe('Formulaire d\'inscription', () => {
    it('test 1 - inscription OK', () => {
        cy.visit('http://127.0.0.1:8000/register');

        // Entrer le nom d'utilisateur et le mot de passe
        cy.get('#registration_form_firstname').type('nvvsfnqn');
        cy.get('#registration_form_lastname').type('nonjfneze');
        cy.get('#registration_form_email').type('mange@mange.fr');
        cy.get('#registration_form_plainPassword').type('password');
        cy.get('[type="checkbox"]').check();

        // Soumettre le formulaire
        cy.get('button[type="submit"]').click();
    });

    it('test 2 - inscription KO', () => {
        cy.visit('http://127.0.0.1:8000/register');

        // Entrer un nom d'utilisateur et un mot de passe incorrects
        cy.get('#registration_form_firstname').type('loup');
        cy.get('#registration_form_lastname').type('loup');
        cy.get('#registration_form_email').type('woufwouf.fr');
        cy.get('#registration_form_plainPassword').type('password');
        cy.get('[type="checkbox"]').uncheck();

        // Soumettre le formulaire@
        cy.get('button[type="submit"]').click();
    });
});