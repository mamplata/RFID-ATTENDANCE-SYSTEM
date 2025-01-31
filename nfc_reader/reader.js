var pcsc = require('pcsclite');
var axios = require('axios'); // Install axios with `npm install axios`
var pcsc = pcsc();

pcsc.on('reader', function(reader) {
    console.log('New reader detected', reader.name);

    reader.on('error', function(err) {
        console.log('Error(', this.name, '):', err.message);
    });

    reader.on('status', function(status) {
        console.log('Status(', this.name, '):', status);
        
        var changes = this.state ^ status.state;
        if (changes) {
            if ((changes & this.SCARD_STATE_EMPTY) && (status.state & this.SCARD_STATE_EMPTY)) {
                console.log("Card removed");
                reader.disconnect(reader.SCARD_LEAVE_CARD, function(err) {
                    if (err) {
                        console.log(err);
                    } else {
                        console.log('Disconnected');
                    }
                });
            } else if ((changes & this.SCARD_STATE_PRESENT) && (status.state & this.SCARD_STATE_PRESENT)) {
                console.log("Card inserted");
                reader.connect({ share_mode: this.SCARD_SHARE_SHARED }, function(err, protocol) {
                    if (err) {
                        console.log(err);
                    } else {
                        console.log('Protocol(', reader.name, '):', protocol);
                        
                        const getUIDCommand = Buffer.from([0xFF, 0xCA, 0x00, 0x00, 0x00]);

                        reader.transmit(getUIDCommand, 40, protocol, function(err, data) {
                            if (err) {
                                console.log(err);
                            } else {
                                const uid = data.toString('hex').toUpperCase();
                                console.log('UID:', uid);

                                // Send UID to Laravel via API
                                axios.post('http://127.0.0.1:8000/api/store-uid', { uid })
                                    .then(response => {
                                        console.log('UID sent successfully:', response.data);
                                    })
                                    .catch(error => {
                                        console.error('Error sending UID:', error);
                                    });
                            }
                        });
                    }
                });
            }
        }
    });

    reader.on('end', function() {
        console.log('Reader', this.name, 'removed');
    });
});

pcsc.on('error', function(err) {
    console.log('PCSC error', err.message);
});
