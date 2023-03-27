#Project Setup

#Ctl + ` to open terminal window 

#run these 2 commands only for the 1st time of the set up
npm install
composer install

#remember to change url in package.json to localhost url

#run these 2 commands everytime I open the project
npm run watch
npm run browser:sync

#whenever there's a change run these 2 commands to generate minimized css and js files
npm run lint:scss:fix
npm run build

