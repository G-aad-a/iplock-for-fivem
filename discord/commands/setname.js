const fetch = require('node-fetch')
const config = require('../config.json')
const { MessageEmbed } = require('discord.js')
var { isAllowed, sendWebhook } = require("../Functions.js");
module.exports.run = async (client, message, args) => {

    if(!isAllowed(message)) {
        return message.reply(":/")
    }


    let target = args[0]
    let servername = args.slice(1).join(" ")
    var embed = new MessageEmbed().setColor("BLACK")

    if (!target) return message.channel.send(embed.setDescription('You need to provide a Key'));
    if (!servername) return message.channel.send(embed.setDescription('You Need To Provide an servername adress!'));

    var embed = new MessageEmbed().setColor("BLACK")
    if (!servername) return message.channel.send(embed.setDescription('You Need To Provide A servername!'));

    try {
        await fetch(`http://${config.host}/action.php?action=changeName&discord=${target}&name=${servername}`)
            .then(res => res.json())
            .then(json => {

                if (json["code"] !== undefined) {
                    switch (json["code"]) {
                        case 29432:
                            message.channel.send(embed.setDescription("User cant be found in the db"))
                            //console.log(message.author.tag + " tried claiming " + key)
                            break;
                        case 299:
                            message.channel.send(embed.setDescription("The Name is now changed to ```" + servername  + "```"))
                            sendWebhook(message.author.username + "#" + message.author.discriminator+" Changed " + target + "'s servername to: " + servername, 3)
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

            .setDescription(`Wrong Key? or already have an active sub?`)


        message.channel.send(embed)
    }




}