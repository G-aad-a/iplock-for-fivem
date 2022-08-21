const fetch = require('node-fetch')
const config = require('../config.json')
const { MessageEmbed } = require('discord.js')
var { isAllowed, sendWebhook } = require("../Functions.js");
module.exports.run = async (client, message, args) => {

    if(!isAllowed(message)) {
        return message.reply(":/")
    }


    let target = message.mentions.users.first()


    if(!target) {
        target = args[0];
    } else {
        target = target.id
    }


    var embed = new MessageEmbed().setColor("BLACK")
    

    if (!target) return message.channel.send(embed.setDescription('You Need To Provide A identifier!'))

    try {
        await fetch(`http://${config.host}/action.php?action=Blacklist&idf=${target}`)
            .then(res => res.json())
            .then(json => {

                if (json["code"] !== undefined) {
                    switch (json["code"]) {
                        case 29432:
                            message.channel.send(embed.setDescription("The user cant be found or is already blacklisted"))
                            //console.log(message.author.tag + " tried claiming " + key)
                            break;
                        case 299:
                            message.channel.send(embed.setDescription("banned ```" + target  + "```"))
                            sendWebhook(message.author.username + "#" + message.author.discriminator+" banned " + target, 1)
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

            .setDescription(`E`)


        message.channel.send(embed)
    }




}