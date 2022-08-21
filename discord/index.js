var Discord = require('discord.js')
var client = new Discord.Client()
var config = require('./config.json')
var fs = require('fs')

client.commands = new Discord.Collection();



fs.readdirSync("./commands").forEach(i => {
    if (!i.endsWith(".js")) return;
    let commandFile = i.split(".")[0].trim()
    let cmd = require(`./commands/${i}`)
    client.commands.set(commandFile, require(`./commands/${commandFile}.js`))
})


const eventFiles = fs.readdirSync("./events/")
eventFiles.forEach(file => {
    const eventName = file.split(".")[0];
    const event = require(`./events/${file}`);
    client.on(eventName, event.bind(null, client));
});



client.login(config.token)