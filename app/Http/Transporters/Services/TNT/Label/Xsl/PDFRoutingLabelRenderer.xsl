<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:fo="http://www.w3.org/1999/XSL/Format"
                xmlns:url="http://whatever/java/java.net.URLEncoder"> 

<xsl:import href="PDFItalianDomesticRoutingLabelRenderer.xsl"/>
<xsl:import href="PDFFrenchDomesticRoutingLabelRenderer.xsl"/>
<xsl:import href="PDFRestOfWorldRoutingLabelRenderer.xsl"/>

<xsl:output method="xml" indent="yes" /> 

<xsl:param name="twoDbarcode_url" />
<xsl:param name="barcode_url" />
<xsl:param name="code128Bbarcode_url" />
<xsl:param name="int2of5barcode_url" />
<xsl:param name="images_dir" />

<xsl:template match="/"> 
   <fo:root xmlns:fo="http://www.w3.org/1999/XSL/Format"> 
      <fo:layout-master-set> 
         <fo:simple-page-master master-name="expressLabel"
                                page-height="29.7cm" page-width="21.0cm"
                                margin="0.5cm"> 
            <fo:region-body /> 
         </fo:simple-page-master> 
      </fo:layout-master-set> 
      <fo:page-sequence master-reference="expressLabel"> 

<!-- Page content goes here -->
         <fo:flow flow-name="xsl-region-body"> 

			<xsl:choose>
                <xsl:when test="(//consignmentLabelData/sender/country = 'IT') and (//consignmentLabelData/marketDisplay = 'DOM')">
                    <xsl:for-each select="//consignment/pieceLabelData"> 
                        <xsl:call-template name="ItalianDomesticPdf" />
                    </xsl:for-each> 
                </xsl:when>
                <xsl:when test="(//consignmentLabelData/sender/country = 'FR') and (//consignmentLabelData/marketDisplay = 'DOM')">
                    <xsl:for-each select="//consignment/pieceLabelData"> 
                        <xsl:call-template name="FrenchDomesticPdf" />
                    </xsl:for-each> 
                </xsl:when>
				<xsl:otherwise>
           			<xsl:for-each select="//consignment/pieceLabelData"> 
						<xsl:call-template name="RestOfWorldPdf" />
           			</xsl:for-each> 
				</xsl:otherwise>
			</xsl:choose>

         </fo:flow> 
      </fo:page-sequence> 
   </fo:root> 
   
</xsl:template> 
 
</xsl:stylesheet>