# Project-Kringloop-Centrum-Duurzaam


# Database Installatie

Om de website te gebruiken, moet je eerst de database instellen. Volg deze stappen en test de login om ervoor te zorgen dat alles correct werkt.

1. **Controleer Bestanden** - Zorg ervoor dat alle benodigde bestanden zich in de `htdocs` map van XAMPP bevinden.
2. **Start XAMPP Services** - Open XAMPP en start zowel Apache als MySQL.
3. **Toegang tot phpMyAdmin** - Zodra MySQL is gestart, klik je op de **Admin** knop naast MySQL.
4. **Database Aanmaken:**

   * In phpMyAdmin, klik je op **Nieuw** in het linker paneel.
   * Noem de nieuwe database **duurzaam** (zorg ervoor dat je dit exact zo spelt, anders maakt de website geen verbinding!).
5. **Database Importeren:**

   * Klik op je zojuist gemaakte database.
   * Ga naar het tabblad **Importeren**.
   * Klik op **Bestand Kiezen** en selecteer `duurzaam.sql` uit de MySQL map.
   * Scroll omlaag en druk op **Importeren**.
6. **Bevestiging** - Zodra het importeren klaar is, is de database gereed.

🎉 Gefeliciteerd! Je database is nu ingesteld en de website zou goed moeten functioneren.