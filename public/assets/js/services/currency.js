export default function currency(format, currency, value){
  return new Intl.NumberFormat(format, { style: 'currency', currency }).format(value);
}