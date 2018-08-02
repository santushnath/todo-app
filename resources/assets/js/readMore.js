export default function read_more( text ) {
    var text_content = text.split(" ");
    var less_content = text_content.slice(0, 15);

    return less_content.join(' ');
}