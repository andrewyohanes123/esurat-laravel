import React, { Component } from "react";
import {UncontrolledDropdown, DropdownItem, DropdownMenu, DropdownToggle} from 'reactstrap';
import {FaBell} from 'react-icons/fa'
import ReactDOM from 'react-dom';
import axios from 'axios';
import moment from 'moment';
import 'moment/locale/id'

export default class Notifications extends Component {
    constructor(props) {
        super(props);

        this.state = {
            notifications : [],
        }

        this.getNotifications = this.getNotifications.bind(this);
    }

    componentDidMount() {
        moment.locale('id');
        this.getNotifications();
    }


    getNotifications() {
        axios.get('/api/notifications').then(({data : {data : notifications}}) => this.setState({ notifications }));
    }

    render() {
        return (
        <>
        <UncontrolledDropdown nav>
            <DropdownToggle nav>
                <FaBell />
            </DropdownToggle>
            <DropdownMenu className="shadow-sm" right>
                {this.state.notifications.length === 0 && 
                <DropdownItem disabled>
                    <p className="text-center text-muted m-0">Tidak ada notifikasi</p>
                    <p className="small m-0">Silahkan periksa kembali</p>
                </DropdownItem>
                }
                { this.state.notifications.map(notif => (<DropdownItem key={notif.id}>
                    <h6 className="m-0">Disposisi Baru</h6>
                    {/* <hr/> */}
                    <p className="text-muted m-0">{notif.from_user[0].name} mengirimi surat : {notif.disposition.reference_number}</p>
                    <p className="m-0 small">{moment(notif.created_at).format('dddd, DD MMMM YYYY hh:mm:ss')}</p>
                </DropdownItem>)) }
            </DropdownMenu>
        </UncontrolledDropdown>
        {/* <li className="nav-item"><a href="#" className="nav-link">Link</a></li> */}
        </>
        );
    }
}

if (document.getElementById('notification')) {
	ReactDOM.render(<Notifications />, document.getElementById('notification'))
}
