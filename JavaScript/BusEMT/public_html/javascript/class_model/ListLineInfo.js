/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class ListLineInfo {
    groupNumber;
    line;
    label;
    nameA;
    nameB;

    getGroupNumber() {
        return groupNumber;
    }

    setGroupNumber(groupNumber) {
        this.groupNumber = groupNumber;
    }

    getLine() {
        return line;
    }

    setLine(line) {
        this.line = line;
    }

    getLabel() {
        return label;
    }

    setLabel(label) {
        this.label = label;
    }

    getNameA() {
        return nameA;
    }

    setNameA(nameA) {
        this.nameA = nameA;
    }

    getNameB() {
        return nameB;
    }

    setNameB(nameB) {
        this.nameB = nameB;
    }

    @Override
    toString() {
        return "Línea " + label + "      " + nameA + "- " + nameB;
    }

}


