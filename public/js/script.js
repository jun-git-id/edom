const average = arr => arr.reduce((sume, el) => sume + el, 0) / arr.length;

const ambilKesimpulan = nilai => {
    let kesimpulan = '';

    if (nilai == 4) {
        kesimpulan = 'Baik Sekali';
    } else if (nilai >= 3) {
        kesimpulan = 'Baik';
    } else if (nilai >= 2) {
        kesimpulan = 'Cukup';
    } else if (nilai >= 1) {
        kesimpulan = 'Buruk';
    }

    return kesimpulan;
}

const tampilTahunAk = url => {



    $.get(url, data => {
        tampilData(data);
    });

    const tampilData = data => {

        data.forEach( dt => {
            let sel = '';

            if( dt.id == data[data.length - 1].id){
                sel = 'selected';
            }


            const el = `<option value="${dt.id}" ${sel} >${dt.tahun} ${dt.ganjil_genap}</option>`;

            $('#tahun_akademik').append(el);

        });
    };


};

const randomWarna = () => {
    const color = [
        'primary',
        'secondary',
        'success',
        'danger',
        'warning',
        'info',
        'dark'
    ];



    return color[Math.floor(Math.random() * 6)];
}
