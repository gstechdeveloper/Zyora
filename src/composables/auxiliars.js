export function floatToCurrency(value, locale = "pt-BR", currency = "BRL") {
        return value.toLocaleString(locale, {
            style: "currency",
            currency: currency,
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
    });
}

export function formatDate(date, hour=true) {
        const d = new Date(date)
        const day = String(d.getDate()).padStart(2, '0')
        const month = String(d.getMonth() + 1).padStart(2, '0')
        const year = d.getFullYear()
        if(hour){
            const hours = String(d.getHours()).padStart(2, '0')
            const minutes = String(d.getMinutes()).padStart(2, '0')
            const seconds = String(d.getSeconds()).padStart(2, '0')

            return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`
        }else{
            return `${day}/${month}/${year}`            
        }

    
}