# PawnGen
Sourcepawn documentation generation.

# Prerequisites
1. PHP `>= 7.0`

# Installation
1. Clone the repository `git clone git@github.com:alliedmodders/pawn-docgen.git`
3. Copy the `env.template.php` to `env.php` and update the database credentials

# Generating the documentation 
1. Setup the database tables `php command-centre create-tables`
2. Generate the includes folder `php command-centre get-include {URL-TO-SM-VERSION}` (If the URL is left blank it will default to the latest version)
3. Run the generation `php command-centre generate`

# Running locally
To run a local version use

`php command-centre serve {PORT}`

The default port is `5000`

# Contributors
[B3none](https://github.com/b3none) for the latest updates.

[XPaw](https://xpaw.me) for the original port.

Also please see the [contributors](https://github.com/alliedmodders/pawn-docgen/graphs/contributors).