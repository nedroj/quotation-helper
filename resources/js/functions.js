window.minutesToTime = function(minutes) {
    let timeParts = [];
    let days = Math.floor(minutes / 1440);
    minutes = minutes - (days * 1440);
    let hours = Math.floor(minutes / 60);
    minutes = minutes - (hours * 60);
    minutes = minutes > 0 ? minutes : 0;
    if (days > 0) {
        timeParts.push(days + 'd');
    }
    if (hours > 0) {
        timeParts.push(hours + 'h');
    }
    if (minutes > 0) {
        timeParts.push(minutes + 'm');
    }
    if (timeParts <= 0){
        // check if time is 0 if time is zero this will crash total in selected component
        timeParts.push(minutes + 'm')
    }


    return timeParts.join(' ');
};
window.minutesToHour = function(minutes) {
    let timeParts = [];
    let hours = Math.floor(minutes / 60);
    minutes = minutes - (hours * 60);
    minutes = minutes > 0 ? minutes : 0;
    if (hours > 0) {
        timeParts.push(hours + 'h');
    }
    if (minutes > 0) {
        timeParts.push(minutes + 'm');
    }
    if (timeParts <= 0){
        // check if time is 0 if time is zero this will crash total in selected component
        timeParts.push(minutes + 'h')
    }

    return timeParts.join(' ');
};
window.timeToMinutes = function(time) {
    let parts = time.split(' ');
    let minutes = 0;
    for (let i = 0; i < parts.length; i++) {
        let part = parts[i];
        let timeParts = part.match(/[^\d]+|\d+/g);
        // console.log(timeParts);
        if (timeParts && timeParts[1]) {
            if (timeParts[1] === 'd') {
                minutes += parseInt(timeParts[0]) * 1440;
            }
            if (timeParts[1] === 'h') {
                minutes += parseInt(timeParts[0]) * 60;
            }
            if (timeParts[1] === 'm') {
                minutes += parseInt(timeParts[0]);
            }
        } else {
            minutes += parseInt(timeParts[0]);
        }
    }
    return minutes;
};
