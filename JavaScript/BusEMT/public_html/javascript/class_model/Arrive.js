/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
"use strict";
class Arrive {
    stopId
    lineId
    destination
    latitude
    longitude
    busPositionType
    busTimeLeft
    busId

    getStopId() {
        return stopId;
    }

    setStopId(stopId) {
        this.stopId = stopId;
    }

    getLineId() {
        return lineId;
    }

    setLineId(lineId) {
        this.lineId = lineId;
    }

    getDestination() {
        return destination;
    }

    setDestination(destination) {
        this.destination = destination;
    }

    getLatitude() {
        return latitude;
    }

    setLatitude(latitude) {
        this.latitude = latitude;
    }

    getLongitude() {
        return longitude;
    }

    setLongitude(longitude) {
        this.longitude = longitude;
    }

    getBusPositionType() {
        return busPositionType;
    }

    setBusPositionType(busPositionType) {
        this.busPositionType = busPositionType;
    }

    getBusTimeLeft() {
        return busTimeLeft;
    }

    setBusTimeLeft(busTimeLeft) {
        this.busTimeLeft = busTimeLeft;
    }

    getBusId() {
        return busId;
    }

    setBusId(busId) {
        this.busId = busId;
    }

}

