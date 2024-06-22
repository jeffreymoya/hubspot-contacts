import React from 'react';
import {ContactTableProps} from "@/app/lib/types";

const ContactTable: React.FC<ContactTableProps> = ({children, data}) => {

    return (
        <>
            <table className="min-w-full bg-white border border-gray-300 text-sm">
                <thead>
                <tr>
                    <th className="table-header">Email</th>
                    <th className="table-header">First Name</th>
                    <th className="table-header">Last Name</th>
                    <th className="table-header">Customer Date</th>
                    <th className="table-header">Lead Date</th>
                </tr>
                </thead>
                <tbody>
                {data.map(contact => (
                    <tr key={contact.id}>
                        <td className="table-col">{contact.email}</td>
                        <td className="table-col">{contact.firstName}</td>
                        <td className="table-col">{contact.lastName}</td>
                        <td className="table-col">{contact.becameACustomerDate}</td>
                        <td className="table-col">{contact.becameALeadDate}</td>
                    </tr>
                ))}
                </tbody>
            </table>
            <div className="mx-4">
                {children}
            </div>
        </>
    );
};

export default ContactTable;
