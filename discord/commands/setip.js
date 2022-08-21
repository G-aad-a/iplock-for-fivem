const fetch = require('node-fetch')
const config = require('../config.json')
const { MessageEmbed } = require('discord.js')
var { isAllowed } = require("../Functions.js");
module.exports.run = async (client, message, args) => {

    if(!isAllowed(message)) {
        return message.reply(":/")
    }

    let target = args[0]
    let ip = args[1]
    var embed = new MessageEmbed().setColor("BLACK")

    if (!target) return message.channel.send(embed.setDescription('You need to provide a Key'));
    if (!ip) return message.channel.send(embed.setDescription('You Need To Provide an ip adress!'));

    if(!target) {
        target = message.author
        ip = args[0]
    } else {
        ip = args[1]
    }

    
    var embed = new MessageEmbed().setColor("BLACK")
    if (!ip) return message.channel.send(embed.setDescription('You Need To Provide A ip!'));

    try {
        await fetch(`http://${config.host}/action.php?action=changeIP&discord=${target}&ip=${ip}`)
            .then(res => res.json())
            .then(json => {

                if (json["code"] !== undefined) {
                    switch (json["code"]) {
                        case 29432:
                            message.channel.send(embed.setDescription("Key cant be found in the Database"))
                            //console.log(message.author.tag + " tried claiming " + key)
                            break;
                        case 299:
                            message.channel.send(embed.setDescription("The IP adress is now changed to ```" + ip  + "```"))
                            sendWebhook(message.author.username + "#" + message.author.discriminator+" Changed " + target + "'s ip to: " + servername, 3)
                        break;
                    }
                    return
                }
                //console.log(json['code'] + "Was claimed by " + message.author.id)
            })

    } catch (e) {

        console.log(e)

        let embed = new MessageEmbed()

            .setColor("BLACK")

            .setDescription(`\`\`\`${e}\`\`\``)


        message.channel.send(embed)
    }




}