export default function CompaniesEditModal({ isOpen, companyId, onClose, onBack }) {
  if (!isOpen) return null;

  const onEdit = async () => {
    
  }

  return (
    <div className="modal-company-edit modal" id="modal-company-edit">
      <div className="modal-main-wrappar">
        <div className="modal-main-header">
          <span className="modal-close-button" onClick={onClose}>&times;</span>
          <div className="modal-main-title">
            <h2>所属会社編集</h2>
          </div>
        </div>

        <div className="modal-main-content">
          <div className="modal-content-edit-input">
            <table className="modal-edit-input-table" bgcolor="#a9a9a9">
              <tbody>
                <tr className="modal-edit-input-name" style={{ height: "24px" }} align="center">
                  <input type="hidden" id="modal-edit-input-id" value={companyId} readOnly />
                  <th width="100px" bgcolor="#D3D3D3">会社名</th>
                  <td className="modal-edit-input-form-name" width="200px" bgcolor="#FFFFFF">
                    <input type="text" id="modal-edit-input-name" />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>

          <div className="modal-content-edit">
            <button className="modal-edit-button edit-button button" id="modal-edit-button" onClick={onEdit}>
              編集
            </button>
          </div>

          <div className="modal-content-return">
            <button className="modal-return-button button" onClick={onBack}>
              戻る
            </button>
          </div>
        </div>
      </div>
    </div>
  );
}
