export default function (num) {
  return new Intl.NumberFormat('zh-TW', {
    style: 'currency',
    currency: 'TWD',
    minimumFractionDigits: 0
  }).format(num)
}

// export default function (num) {
//   const n = Number(num)
//   return `$${n.toFixed(0).replace(/./g, (c, i, a) => {
//     const currency = (i && c !== '.' && ((a.length - i) % 3 === 0) ? `, ${c}`.replace(/\s/g, '') : c)
//     return currency
//   })}`
// }
